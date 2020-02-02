<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed">
                <div class="box-header border-bottom">
                    <div class="row p-1">
                        <h5 class="box-title text-bold"><span class="fa fa-file-user"></span>
                            <?php echo 'My Reports <span class="text-primary">(Flash Report) </span>'; ?>
                        </h5>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($my_reports) && is_array($my_reports) && count($my_reports) > 0): ?>
                            <div class="k-content">
                                <ul id="myReportsTreeView" data-role="treeview">
                                    <?php foreach ($my_reports as $year => $reports) { ?>
                                        <li data-expanded="true">
                                            <span class="fa fa-folder"> <?php echo $year ?></span>

                                            <ul>
                                                <?php foreach ($reports as $report) { ?>
                                                    <li data-expanded="true"
                                                        data-report-submitted="<?php echo isReportSubmitted($report['target_month'], $report['target_year'], $current_user->department_id, 'nmr') ?>"
                                                        data-table-prefix="nmr"
                                                        data-submission-closed="<?php echo $report['closed_status'] ?: '' ?>"
                                                        data-draft-id="<?php echo $report['draft_id'] ?>">
                                                        <span class="fa fa-file-word"> <?php echo $report['target_month'] ?></span>
                                                        <i class="mx-2 text-bold text-sm <?php echo $report['closed_status'] ? 'text-danger submission-closed' : 'text-success' ?>"><?php echo $report['closed_status'] ? '(Closed)' : '(Opened)' ?></i>
                                                        <ul>
                                                            <li>
                                                                <a class="mx-1 k-button view-btn"
                                                                   data-report-submitted="<?php echo isReportSubmitted($report['target_month'], $report['target_year'], $current_user->department_id, 'nmr') ?>"
                                                                   data-table-prefix="nmr"
                                                                   data-draft-id="<?php echo $report['draft_id']; ?>"
                                                                   data-closed-status="<?php echo $report['closed_status'] ?: '' ?>">
                                                                    View
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                <?php } ?>
                                            </ul>

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        <?php else: ?>
                            <h5>No Flash Reports Available!</h5>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
        </div>
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed">
                <div class="box-header border-bottom">
                    <div class="row p-1">
                        <h5 class="box-title text-bold"><span class="fa fa-file-user"></span>
                            <?php echo 'My Reports <span class="text-warning">(Full Report)</span> '; ?>
                        </h5>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($my_reports_fr) && is_array($my_reports_fr) && count($my_reports_fr) > 0): ?>
                            <div class="k-content">
                                <ul id="myReportsTreeView" data-role="treeview">
                                    <?php foreach ($my_reports_fr as $year => $reports) { ?>
                                        <li data-expanded="true">
                                            <span class="fa fa-folder"> <?php echo $year ?></span>

                                            <ul>
                                                <?php foreach ($reports as $report) { ?>
                                                    <li data-expanded="true"
                                                        data-report-submitted="<?php echo isReportSubmitted($report['target_month'], $report['target_year'], $current_user->department_id, 'nmr_fr') ?>"
                                                        data-table-prefix="nmr_fr"
                                                        data-submission-closed="<?php echo $report['closed_status'] ?: '' ?>"
                                                        data-draft-id="<?php echo $report['draft_id'] ?>">
                                                        <span class="fa fa-file-word"> <?php echo $report['target_month'] ?></span>
                                                        <i class="mx-2 text-bold text-sm <?php echo $report['closed_status'] ? 'text-danger submission-closed' : 'text-success' ?>"><?php echo $report['closed_status'] ? '(Closed)' : '(Opened)' ?></i>
                                                        <ul>
                                                            <li>
                                                                <a class="mx-1 k-button view-fr-btn"
                                                                   data-report-submitted="<?php echo isReportSubmitted($report['target_month'], $report['target_year'], $current_user->department_id, 'nmr_fr') ?>"
                                                                   data-table-prefix="nmr_fr"
                                                                   data-draft-id="<?php echo $report['draft_id']; ?>"
                                                                   data-closed-status="<?php echo $report['closed_status'] ?: '' ?>">
                                                                    View
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                <?php } ?>
                                            </ul>

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>

                        <?php else: ?>
                            <h5>No Full Reports Available!</h5>
                        <?php endif; ?>
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
<style>
    .k-editor {
        z-index: -1 !important;
    }
</style>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>
<script>
    let previewEditor;
    let draftWindow;
    let draftId;
    let reportSubmitted;
    let currentTarget;
    /**
     * @type {kendo.ui.PDFViewer}*/
    let pdfViewer;


    $(function () {
        kendo.bind('.k-content');
        jQSelectors.draftViewerWindow = $("<div id='draftViewerWindow'/>").appendTo("body");
        jQSelectors.draftPreviewViewer = $("<div id='draftPreviewViewer'/>").appendTo(jQSelectors.draftViewerWindow);
        jQSelectors.draftPreviewEditor = $("<textarea id='draftPreviewEditor' style='width: 100%;'/>").appendTo("body");

        draftWindow = jQSelectors.draftViewerWindow.kendoWindow({
            modal: true,
            visible: false,
            width: "80%",
            scrollable: false,
            title: {
                encoded: false
            }
            //height: "80%",
            // (Optional) Will limit the percentage dimensions as well:
            // maxWidth: 1200,
            // maxHeight: 800,
            //open: adjustSize
        }).data("kendoWindow");
        pdfViewer = jQSelectors.draftPreviewViewer.kendoPDFViewer({
            pdfjsProcessing: {
                file: ""
            },
            width: "100%",
            height: 550,
            scale: 1,
            toolbar: {
                items: [
                    "pager", "zoom", "toggleSelection", "search", "download", "print",
                    {
                        id: "submitReport",
                        type: "button",
                        text: "Submit Report",
                        icon: "upload",
                        click: function () {
                            let submit = () => {
                                let dfd = $.Deferred();
                                let post = $.post(URL_ROOT + "/pages/submit-report/" + tablePrefix, {
                                    //title: title,
                                    draft_id: draftId,
                                    content: previewEditor.value(),
                                    //spreadsheet_content: JSON.stringify(spreadsheet.toJSON())
                                }, null, "json");
                                draftWindow.close();
                                dfd.resolve(post);
                                return dfd.promise();
                            };
                            if (reportSubmitted) {
                                showWindow('This report has already been submitted. Are you sure you want to update it?')
                                    .done(e => {
                                        submit().done(post => post.done(data => {
                                            let alert = kendoAlert("Report Updated!", "Report updated successfully.");
                                            setTimeout(() => alert.close(), 1500);
                                        }));
                                    });
                            } else {
                                submit().done(post => post.done(data => {
                                    reportSubmitted = 1;
                                    currentTarget.data('reportSubmitted', 1);
                                    let alert = kendoAlert("Report Submitted!", "Report submitted successfully.");
                                    setTimeout(() => alert.close(), 1500);
                                }));
                            }
                        }
                    },
                    {
                        id: "cancel",
                        type: "button",
                        text: "Cancel",
                        icon: "cancel",
                        click: function () {
                            draftWindow.close();
                        }
                    }
                ]
            }
        }).getKendoPDFViewer();
        setTimeout(function () {
            previewEditor = jQSelectors.draftPreviewEditor.kendoEditor({
                tools: [],
                stylesheets: [
                    "<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css",
                    "<?php echo URL_ROOT; ?>/public/custom-assets/css/editor.css"
                ]
            }).data("kendoEditor");

        }, 1000);

        $(".view-btn").on("click", function (e) {
            currentTarget = $(e.currentTarget);
            draftId = currentTarget.data('draftId');
            reportSubmitted = $(e.currentTarget).data('reportSubmitted');
            tablePrefix = $(e.currentTarget).data('tablePrefix');
            let closedStatus = $(e.currentTarget).data('closedStatus') === 1;
            let toolbar = pdfViewer.toolbar;
            window.previewDraftId = draftId;
            $.get(URL_ROOT + "/pages/fetchDraft/" + draftId + "/" + tablePrefix).done(function (data) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "1.3cm",
                    multipage: true,
                    forcePageBreak: ".page-break"
                }).then(function (group) {
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (data) {
                    if (closedStatus)
                        toolbar.hide("#submitReport");
                    else
                        toolbar.show("#submitReport");
                    draftWindow.center().open().maximize().title(closedStatus ? {
                        encoded: false,
                        text: "<span class=\"text-danger text-bold\">Report Submission Closed!</span>"
                    } : '');
                    pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                    setTimeout(() => pdfViewer.activatePage(1), 500)
                });
            });
        });

        $(".view-fr-btn").on("click", function (e) {
            currentTarget = $(e.currentTarget);
            reportSubmitted = currentTarget.data('reportSubmitted');
            draftId = $(e.currentTarget).data('draftId');
            tablePrefix = $(e.currentTarget).data('tablePrefix');
            let closedStatus = $(e.currentTarget).data('closedStatus') === 1;
            let toolbar = pdfViewer.toolbar;
            window.previewDraftId = draftId;
            $.get(URL_ROOT + "/pages/fetchDraft/" + draftId + '/' + tablePrefix).done(function (data) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "1.3cm",
                    forcePageBreak: ".page-break",
                    multipage: true
                }).then(function (group) {
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (data) {
                    if (closedStatus)
                        toolbar.hide("#submitReport");
                    else
                        toolbar.show("#submitReport");
                    draftWindow.center().open().maximize().title(closedStatus ? {
                        encoded: false,
                        text: "<span class=\"text-danger text-bold\">Report Submission Closed!</span>"
                    } : '');
                    pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                    setTimeout(() => pdfViewer.activatePage(1), 500)
                });
            });
        })
    });

    function adjustSize() {
        // For small screens, maximize the window when it is shown.
        // You can also make the check again in $(window).resize if you want to
        // but you will have to change the way to reference the widget and then
        // to use $("#theWindow").data("kendoWindow").
        // Alternatively, you may want to .center() the window.

        if ($(window).width() < 800 || $(window).height() < 600) {
            this.maximize();
        }
    }

    $(".delete-draft-btn").on("click", function (e) {
        let draft_id = $(e.currentTarget).data('draftId');
        let parent = $($(e.currentTarget).data('parent'));
        let draftsContainer = parent.parent('.row');
        kendo.confirm("Are you sure you want to delete this draft?").done(function () {
            $.get(URL_ROOT + "/pages/delete-draft/" + draft_id).done(function () {
                parent.remove();
                if (draftsContainer.children().length === 0)
                    draftsContainer.append('<h5>No Draft Available!</h5>');
            });
        })
    });

    $(".delete-preloaded-draft-btn").on("click", function (e) {
        let draft_id = $(e.currentTarget).data('draftId');
        let parent = $($(e.currentTarget).data('parent'));
        let draftsContainer = parent.parent('.row');
        kendo.confirm("Are you sure you want to delete this draft?").done(function () {
            $.get(URL_ROOT + "/pages/delete-preloaded-draft/" + draft_id).done(function () {
                parent.remove();
                if (draftsContainer.children().length === 0)
                    draftsContainer.append('<h5>No Preloaded Draft Available!</h5>');
            });
        })
    });

</script>
</body>
</html>