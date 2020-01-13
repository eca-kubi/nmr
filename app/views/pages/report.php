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
                    <h5 class="box-title text-bold"><span class="fa fa-edit text-primary"></span> Word Editor</h5>
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
                                              style="height: 400px"><?php echo isset($content)? $content : ''; ?></textarea>
                                    <input type="hidden" id="draft_id" name="draft_id"
                                           value="<?php echo isset($draft_id) ? $draft_id : ''; ?>">
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
    let spreadsheet;
    let chartsTabStrip;
    let editorTabStrip;
    let chartTabs = [];
    let charts = [];
    let editor;
    let firstSheetLoading = true;
    let chartConfiguration = {
        series: {
            goldProducedBudgetOunces: {
                color: {
                    goldProduced: "#5b9bd5",
                    budgetOunces: "#ed7d31"
                }
            }
        }
    };
    $(function () {
        spreadsheetTemplates = JSON.parse($("#spreadsheetTemplates").val());
        $(window).on("resize", function () {
            kendo.resize($("#chartsTabstripHolder"));
            spreadsheet.resize(true);
        });

        editorTabStrip = $("#editorTabStrip").kendoTabStrip({
            select(e) {
                if (e.contentElement.id === "previewTab") {
                    $("#previewContent").html($(".k-editable-area iframe")[0].contentDocument.documentElement.innerHTML);
                }
            }
        });

        chartsTabStrip = $("#chartsTabStrip").kendoTabStrip({
            activate(e) {
                let emptyChartPlaceholder = $("#emptyChartPlaceHolder");
                spreadsheet.activeSheet(spreadsheet.sheetByName($(e.item).text()));
                updateChartTabs();
                if (e.contentElement.innerText.length)
                    emptyChartPlaceholder.hide();
                else
                    emptyChartPlaceholder.show();
            }
        }).data("kendoTabStrip");

        $("#editorActionToolbar").kendoToolBar({
            items: [
                {
                    type: "button",
                    text: "Save Draft",
                    icon: "save",
                    click: function (e) {
                        $.post({
                            url: URL_ROOT + "/pages/save-draft",
                            data: $("#editorForm").serialize(),
                            dataType: 'json'
                        }).done(function (response, textStatus, jQueryXHR) {
                            if (response.success) {
                                let kAlert = kendoAlert('Save Draft', 'Draft saved successfully!');
                                if (response.draft_id)
                                    $('#draft_id').val(response.draft_id);
                                setTimeout(() => kAlert.close(), 2500);
                            } else {
                                let kAlert = kendoAlert('Save Draft', '<span class="text-danger">Draft failed to save!</span>');
                            }
                        });
                    }
                },
                {
                    type: "button",
                    text: "Clear",
                    icon: "refresh-clear",
                    click: function () {
                        editor.value("");
                    }
                }
            ]
        });

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
                "<?php echo URL_ROOT; ?>/public/custom-assets/css/editor.css"
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
                    //"open",
                    "exportAs",
                    //["cut", "copy", "paste"],
                    //["bold", "italic", "underline"],
                    "fontSize",
                    //"fontFamily",
                    //"alignment",
                    //"format"
                ],
                insert: false,
                data: false
            },
            columns: 13,
            rows: 6,
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
                spreadsheetTemplates.map((e) => ds.push({id: e.id, description: e.description}));
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


    });

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
        let data = [];
        let sheetName = sheet.name();
        let chart;
        /* if (Array.prototype.map.call(chartsTabStrip.items(), (item => item.textContent)).includes(sheetName)) {
             spreadsheet.activeSheet(sheet);
             return;
         }*/
        chartsTabStrip.append([{
            text: sheetName,
            content: '<div id="' + sheetName + '" style="height: 100%; width: 100%"></div>'
        }]);
        let div = $("[id='" + sheetName + "']");
        let divParent = div.parent("[role=tabpanel]");
        chartsTabStrip.activateTab(divParent);
        //chartTabs[sheetName] = divParent.attr("id");
        //updateChartTabs();
        let kendoChartOptions = {
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
            legend: {
                visible: true,
                position: "top"
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
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.goldProduced
                    },
                    {
                        field: "['HEAD GRADE']",
                        categoryField: categoryField,
                        type: "line",
                        name: "HEAD GRADE",
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
            setTimeout(function () {
                overlayScrollbarsInstances['body'].scroll($("#chartsTabstripHolder"), 5500, {
                    x: "linear",
                    y: "easeOutBounce"
                })
            }, 500)
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
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.goldProduced
                    },
                    {
                        field: "['TONS MILLED']",
                        categoryField: categoryField,
                        type: "line",
                        name: "TONS MILLED",
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
            setTimeout(function () {
                overlayScrollbarsInstances['body'].scroll($("#chartsTabstripHolder"), 5500, {
                    x: "linear",
                    y: "easeOutBounce"
                })
            }, 500)
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
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.goldProduced
                    },
                    {
                        field: "['BUDGET OUNCES']",
                        categoryField: categoryField,
                        type: "line",
                        name: "BUDGET OUNCES",
                        color: chartConfiguration.series.goldProducedBudgetOunces.color.budgetOunces
                    }
                ],
            })).data("kendoChart");
            charts[sheetName] = chart;
            bindChart(chart, sheet, valueRange, fieldRange);
            setTimeout(function () {
                overlayScrollbarsInstances['body'].scroll($("#chartsTabstripHolder"), 5500, {
                    x: "linear",
                    y: "easeOutBounce"
                })
            }, 500)
        }
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
            draw.exportPDF(newGroup, {paperSize: 'A4'}).done(data => kendo.saveAs({
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

</script>
</body>
</html>