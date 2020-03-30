<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>

<style>
    [data-role=spreadsheettoolbar] [data-tool], [data-role=editortoolbar] .k-tool-group, [data-role=borderpalette] a[role=button] {
        margin: 1px;
    }

    .pane-content {
        padding: 0 1px;
    }

</style>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight">
    <!-- content -->
    <section class="content blockable invisible">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed border-primary">
                <div class="box-header">
                    <h6 class="box-title text-primary">
                        <?php echo 'Daily Management Report (' . $current_user->department . ')' ?>
                    </h6>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="toolbar"></div>
                    <div id="spreadsheet" style="width: 100%"></div>
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
<input id="dmr" type="hidden"
       value='<?php echo json_encode(getDmr($current_user->department, date('Y-m-d', strtotime(now()))) ?? []); ?>'>
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>

<style>
    /*Hide remove button for default sheet*/
    .k-spreadsheet-sheets-items .k-item:first-child .k-spreadsheet-sheets-remove {
        display: none !important;
    }
</style>
<script>
    /**
     * @type {kendo.ui.Spreadsheet}
     * */
    let spreadsheet;

    let currentUser = JSON.parse(`<?php echo json_encode(currentUser()); ?>`);

    let dmr = JSON.parse($("#dmr").val() || "{}");
    dmr.content = JSON.parse(dmr.content || "{}");

    let toolbar;

    let postJson = function (url, postData, doneCallback) {
        progress('#spreadsheet', true);
        url = url || URL_ROOT + '/pages/new-dmr';
        postData = postData || {content: JSON.stringify(spreadsheet.toJSON().sheets[0].rows[6])};
        doneCallback = doneCallback || function (data) {
            progress('#spreadsheet');
            let title = data.success ? 'Success!' : 'Error!';
            let alert = kendoAlert(title, data.message);
            if (data.success && postData.submitted) {
                toolbar.element.find("#submitBtn").html('<span class="k-icon k-i-check"></span>' + 'Update Report');
            }
            setTimeout(() => alert.close(), 1350);
        };

        $.post(url, postData, null, "json").done(d => {
            doneCallback(d)
        });
    };

    let save = function (e) {
        postJson();
    };

    let submit = function (e) {
        let postData = {submitted: 1, content: JSON.stringify(spreadsheet.toJSON().sheets[0].rows[6])};
        postJson(undefined, postData);
    };

    // overide kendo.spreadsheet.SheetsBar.prototype._createEditor to avoid showing rename editor for default sheet
    let SheetsBar = kendo.spreadsheet.SheetsBar;
    SheetsBar.prototype._createEditor = function () {
        const DOT = '.';
        if (this._sheets[this._selectedIndex].name() == currentUser.department) return false;
        if (this._editor) {
            return;
        }
        this._renderSheets(this._sheets, this._selectedIndex, true);
        this._editor = this.element.find(kendo.format('input{0}{1}', DOT, SheetsBar.classNames.sheetsBarEditor)).focus().on('keydown', this._onEditorKeydown.bind(this)).on('blur', this._onEditorBlur.bind(this));
    };

    SheetsBar.prototype._onSheetReorderStart = function (e) {
        e.preventDefault();
    };


    $(function () {

        toolbar = $("#toolbar").kendoToolBar({
            items: [
                {
                    type: "button",
                    text: "Save",
                    icon: "save",
                    click: save
                },
                {
                    id: "submitBtn",
                    type: "button",
                    text: dmr.submitted ? "Update Report" : "Submit",
                    icon: "check",
                    click: submit
                },
                <?php if (isITAdmin($current_user->user_id)): ?>

                <?php endif; ?>
            ]
        }).data("kendoToolBar");

        spreadsheet = $('#spreadsheet').kendoSpreadsheet({
            columnWidth: 50,
            toolbar: {
                home: [
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
            sheets: [
                {
                    "name": currentUser.department,
                    "rows": [
                        {
                            "index": 0,
                            "height": 21,
                            "cells": [
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                }
                            ]
                        },
                        {
                            "index": 1,
                            "height": 29,
                            "cells": [
                                {
                                    "value": "DAILY MANAGEMENT REPORT",
                                    "background": "#bfbfbf",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 2,
                            "height": 29,
                            "cells": [
                                {
                                    "value": "DATE: " + (dmr.date? moment(dmr.date).format('DD-MM-YYYY') : moment().format('DD-MM-YYYY')),
                                    "background": "#f8cbad",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 3,
                            "height": 10,
                            "cells": [
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 4,
                            "height": 56,
                            "cells": [
                                {
                                    "value": "DEPARTMENT",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "value": "HIGHLIGHTS",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "value": "LOWLIGHTS",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "value": "EMERGING ISSUES",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "value": "PRIORITY DELIVERABLES",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "value": "DAILY TARGET           (IF ANY)",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "value": "DAILY ACTUAL     (IF ANY)",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "value": "MTD TARGET       (IF ANY)",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "value": "MTD ACTUAL (IF ANY)",
                                    "background": "#e2f0d9",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 16,
                                    "bold": true,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 5,
                            "height": 133,
                            "cells": [
                                {
                                    "value": "Reporting Department",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "center",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "value": "1. What are the good things that happened yesterday?\r\n2. Do we have any good performance trends going on?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "value": "1. What are the bad things that happened yesterday?\r\n2. What targets were not achieved?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "value": "1. Do we have any bad performance trends going on?\r\n2. Any other issues that can affect the business ability to meet month end planned targets?\r\n3. Are there MTD performance on the key KPIs that are falling behind and in danger of not achieving month forecast? E.g. Ounces poured?, Ounces recovered? Recovery? Tons milled? Grade milled? Tons crushed? Grade crushed? ",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "value": "1. What is being done to manage the 'emerging issues'?\r\n2. What is the mitigation/ recovery plan? - By who? - By when?\r\n3. What can senior management do to help?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "value": "What is our daily target for the KPIs?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "value": "What was yesterday's performance on the KPIs",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "value": "What is our MTD target for the KPIs?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "value": "What is the performance so far, for the month?",
                                    "background": "#ffe699",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 12,
                                    "textAlign": "left",
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": dmr.content.index || 6,
                            "height": dmr.content.height || 109,
                            "cells": dmr.content.cells || [
                                {
                                    "value": currentUser.department,
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        }
                        /*
                        {
                            "index": 7,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "SECURITY",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 8,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "SRD",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 9,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "FINANCE",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 10,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "HR",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 11,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "PROCUREMENT",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 12,
                            "height": 109,
                            "cells": [
                                {
                                    "value": "IT",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "value": "\r\nSafety Mobile App Dev't on-going\r\nRemote Meeting conducted with IT Team",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "value": "Remote Access List not completed\r\n- Yet to receive list from SRD, Exploration, Mining",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "value": "Stockpile impeding Radio communication\r\n",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "value": "izengoff to work on antennae (MTN Tower)",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "value": "\r\n\r\nPictures of antennae sent to DWA\r\n\r\n",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "wrap": true,
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 13,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "MINING",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 14,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "GEOLOGY",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 15,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "PROCESSING",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 16,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "ENGINEERING",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 17,
                            "height": 28,
                            "cells": [
                                {
                                    "value": "EXPLORATION",
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "bold": true,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "color": "#000000",
                                    "fontFamily": "Calibri",
                                    "fontSize": 14.666666666667,
                                    "verticalAlign": "center",
                                    "borderLeft": {
                                        "size": 1,
                                        "color": "#000000"
                                    },
                                    "borderRight": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "borderBottom": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                },
                                {
                                    "borderLeft": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 9
                                }
                            ]
                        },
                        {
                            "index": 18,
                            "cells": [
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 0
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 1
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 2
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 3
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 4
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 5
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 6
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 7
                                },
                                {
                                    "borderTop": {
                                        "size": 2,
                                        "color": "#000000"
                                    },
                                    "index": 8
                                }
                            ]
                        }
                        */
                    ],
                    "columns": [
                        {
                            "index": 0,
                            "width": 150.484375
                        },
                        {
                            "index": 1,
                            "width": 216.48046875
                        },
                        {
                            "index": 2,
                            "width": 238.4921875
                        },
                        {
                            "index": 3,
                            "width": 311.47265625
                        },
                        {
                            "index": 4,
                            "width": 358.4765625
                        },
                        {
                            "index": 5,
                            "width": 222.46875
                        },
                        {
                            "index": 6,
                            "width": 201.46875
                        },
                        {
                            "index": 7,
                            "width": 212.48828125
                        },
                        {
                            "index": 8,
                            "width": 301.4921875
                        }
                    ],
                    "selection": "D31:D31",
                    "activeCell": "D31:D31",
                    "frozenRows": 0,
                    "frozenColumns": 0,
                    "showGridLines": true,
                    "gridLinesColor": null,
                    "mergedCells": [
                        "A2:I2"
                    ],
                    "hyperlinks": [],
                    "defaultCellStyle": {
                        "fontFamily": "Arial",
                        "fontSize": "12"
                    },
                    "drawings": []
                }
            ],
            removeSheet(e) {
                if (e.sheet.name() == currentUser.department) {
                    e.preventDefault();
                }
            }
        }).data("kendoSpreadsheet");

        //spreadsheet.activeSheet().range("A:A").enable(false);
        //spreadsheet.activeSheet().range("1:6").enable(false);
        spreadsheet.activeSheet().range("7:7").verticalAlign("top");

        // Limit image upload size
        /*
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

    function adjustWindowHeight(w) {
        let overlayHeight = $(".k-overlay").height();
        let win = $(w);
        if (overlayHeight && win.height() > (overlayHeight * 0.7))
            win.height(0.7 * overlayHeight);
        win.getKendoWindow().center();
        initOverlayScrollbars(win);
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

    kendo.ui.Spreadsheet.prototype.getSheetNames = function () {
        return this.sheets().map(s => s.name());
    };


</script>
</body>
</html>
