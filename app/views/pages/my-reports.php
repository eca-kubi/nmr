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
                            My Reports <span class="text-<?php echo $table_prefix === 'nmr'? 'primary' : 'warning'; ?>">( <?php echo flashOrFull($table_prefix)?> Report) </span>
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
                                                        data-table-prefix="<?php echo $table_prefix; ?>"
                                                        data-target-year="<?php echo $report['target_year'] ?>"
                                                    >
                                                        <span class="fa fa-file-word"> <?php echo $report['target_month'] ?></span>
                                                        <i class="mx-2 text-bold text-sm <?php echo $report['closed_status'] ? 'text-danger submission-closed' : 'text-success' ?>"><?php echo $report['closed_status'] ? '(Closed)' : '(Opened)' ?></i>
                                                        <ul>
                                                            <li>
                                                                <a class="mx-1 k-button <?php echo $table_prefix === 'nmr_fr' ? 'view-fr-btn' : 'view-btn'; ?>"
                                                                   data-report-submitted="<?php echo isReportSubmitted($report['target_month'], $report['target_year'], $current_user->department_id, $table_prefix) ?>"
                                                                   data-table-prefix="<?php echo $table_prefix ?>"
                                                                   data-spreadsheet-content='<?php echo $report['spreadsheet_content'] ?>'
                                                                   data-target-month="<?php echo $report['target_month'] ?>"
                                                                   data-target-year="<?php echo $report['target_year'] ?>"
                                                                   data-title="<?php echo $report['title']; ?>"
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
                            <h5>No <?php echo flashOrFull($table_prefix) ?> Reports Available!</h5>
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
        opacity: 0!important;
        /*z-index: -1 !important;
        position: absolute;
        left: -9999px;*/
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
    let reportCache = {};
    let tablePrefix = "<?php echo $table_prefix; ?>";

    $(function () {
        kendo.bind('.k-content');
        jQSelectors.draftViewerWindow = $("<div id='draftViewerWindow'/>").appendTo("body");
        jQSelectors.draftPreviewViewer = $("<div id='draftPreviewViewer'/>").appendTo(jQSelectors.draftViewerWindow);
        jQSelectors.draftPreviewEditor = $("<textarea id='draftPreviewEditor' style='width: 100%;'/>").appendTo("body");

        draftWindow = jQSelectors.draftViewerWindow.kendoWindow({
            modal: true,
            visible: false,
            width: "100%",
            scrollable: false,
            title: {
                encoded: false
            },
            height: 1200
        }).data("kendoWindow");

        pdfViewer = jQSelectors.draftPreviewViewer.kendoPDFViewer({
            pdfjsProcessing: {
                file: ""
            },
            width: "100%",
            height: 800,
            scale: 1.48,
            open(e) {
                setTimeout(() => pdfViewer.activatePage(1), 1000);
                draftWindow.center().open().maximize().title(e.closedStatus ? {
                    encoded: false,
                    text: "<span class=\"text-danger text-bold\">Report Submission Closed!</span>"
                } : '');
            },
            toolbar: {
                items: [
                    "pager", "zoom", "toggleSelection", "search", "download", "print",
                    {
                        id: "edit",
                        type: "button",
                        text: "Edit",
                        icon: "edit",
                        click: function (e) {
                            let target = $(e.target);
                            location.href = URL_ROOT + '/pages/edit-draft/' + target.data('draftId') + '/' + target.data('tablePrefix');
                        }
                    },
                    {
                        id: "submitReport",
                        type: "button",
                        text: "Submit Report",
                        icon: "upload",
                        click: function (e) {
                            let currentTarget = $(e.target);
                            let viewBtn = currentTarget.data('viewBtn');
                            let reportSubmitted = viewBtn.data('reportSubmitted');
                            let draftId = viewBtn.data('draftId');
                            let title = viewBtn.data('title');
                            let tablePrefix = viewBtn.data('tablePrefix');
                            let spreadsheetContent = viewBtn.data('spreadsheetContent');
                            let submit = () => {
                                let dfd = $.Deferred();
                                let post = $.post(URL_ROOT + "/pages/submit-report/" + tablePrefix, {
                                    title: title,
                                    draft_id: draftId,
                                    content: previewEditor.value(),
                                    spreadsheet_content: JSON.stringify(spreadsheetContent)
                                }, null, "json");
                                draftWindow.close();
                                dfd.resolve(post);
                                return dfd.promise();
                            };
                            if (reportSubmitted) {
                                showWindow('This report has already been submitted. Are you sure you want to update it?')
                                    .done(e => {
                                        progress('.content-wrapper', true);
                                        submit().done(post => post.done(data => {
                                            progress('.content-wrapper');
                                            let alert = kendoAlert("Report Submitted!", "Report submitted successfully.");
                                            setTimeout(() => alert.close(), 1500);
                                        }));
                                    });
                            } else {
                                submit().done(post => post.done(data => {
                                    progress('.content-wrapper');
                                    viewBtn.data('reportSubmitted', 1);
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

        jQSelectors.draftPreviewViewer.data('kendoPDFViewer').pageContainer.addClass('bg-gray');

        previewEditor = jQSelectors.draftPreviewEditor.kendoEditor({
            pdf: $.extend({}, pdfExportOptions, {margin: "1cm", fileName: tablePrefix === 'nmr' ? 'FLASH REPORT DRAFT' : 'FULL REPORT DRAFT'}),
            tools: [],
            stylesheets: [
                //"<?php echo URL_ROOT; ?>/public/assets/ckeditor/contents.css?f=<?php echo now() ?> ",
                //"<?php echo URL_ROOT; ?>/public/custom-assets/css/ckeditor-sample-file.css?f=<?php echo now() ?> ",
                //"<?php echo URL_ROOT; ?>/public/assets/ckeditor/plugins/pastefromword/pastefromword.css?f=<?php echo now() ?> ",
                "<?php echo URL_ROOT; ?>/public/assets/fonts/font-face/css/fonts.css?f=<?php echo now() ?> ",
                "<?php echo URL_ROOT; ?>/public/custom-assets/css/k-editor.css?f=<?php echo now() ?> ",
            ]
        }).data("kendoEditor");

        $(".view-btn, .view-fr-btn").on("click", function (e) {
            let currentTarget = $(e.currentTarget);
            let targetMonth = currentTarget.data('targetMonth');
            let targetYear = currentTarget.data('targetYear');
            let draftId = currentTarget.data('draftId');
            let tablePrefix = currentTarget.data('tablePrefix');
            let closedStatus = currentTarget.data('closedStatus') == 1;
            let toolbar = pdfViewer.toolbar;
            let cacheKey = 'my_report_' + draftId;
            let dataUriCacheKey = cacheKey + '_dataUri';
            window.previewDraftId = draftId;
            if (closedStatus) {
                toolbar.hide("#submitReport");
                toolbar.hide("#edit");
            } else {
                toolbar.wrapper.find('#submitReport').data({viewBtn: currentTarget});
                toolbar.wrapper.find('#edit').data({draftId: draftId, tablePrefix: tablePrefix});
                toolbar.show("#submitReport");
                toolbar.show("#edit");
            }

            let viewContent = function (content) {
                toggleNonPrintableElements(previewEditor);
                previewEditor.value(content);
                progress('.content-wrapper', true);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    allPages: true,
                    paperSize: 'A4',
                    margin: tablePrefix == 'nmr_fr' ? {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"} : '1cm',
                    multipage: true,
                    scale: 0.7,
                    forcePageBreak: ".page-break",
                    template: $(`#page-template-body_${tablePrefix}`).html()
                }).then(function (group) {
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (data) {
                    progress('.content-wrapper');
                    pdfViewer.fromFile({data: data.split(',')[1]});
                    pdfViewer.setOptions({
                        messages: {
                            defaultFileName: targetMonth +  ' ' + targetYear + ' ' + (tablePrefix === 'nmr' ? 'FLASH REPORT DRAFT' : 'FULL REPORT DRAFT')
                        }
                    });
                    pdfViewer.trigger('open', {
                        closedStatus: closedStatus,
                        targetMonth: targetMonth,
                        targetYear: targetYear,
                        viewBtn: currentTarget
                    });
                    reportCache[dataUriCacheKey] = data;
                });
            };

            let cached = reportCache[cacheKey];
            let dataUriCache = reportCache[dataUriCacheKey];
            if (dataUriCache) {
                pdfViewer.setOptions({
                    messages: {
                        defaultFileName: targetMonth +  ' ' + targetYear + ' ' + (tablePrefix === 'nmr' ? 'FLASH REPORT DRAFT' : 'FULL REPORT DRAFT')
                    }
                });
                pdfViewer.fromFile({data: dataUriCache.split(',')[1]});
                pdfViewer.trigger('open', {
                    closedStatus: closedStatus,
                    targetMonth: targetMonth,
                    targetYear: targetYear
                })
            } else {
                $.get(URL_ROOT + "/pages/fetchDraft/" + draftId + "/" + tablePrefix).done(function (data) {
                    viewContent(data);
                    //reportCache[cacheKey] = data;
                });
            }
        });

        /* $(".view-fr-btn").on("click", function (e) {
             currentTarget = $(e.currentTarget);
             reportSubmitted = currentTarget.data('reportSubmitted');
             draftId = $(e.currentTarget).data('draftId');
             tablePrefix = $(e.currentTarget).data('tablePrefix');
             let closedStatus = $(e.currentTarget).data('closedStatus') === 1;
             let toolbar = pdfViewer.toolbar;
             window.previewDraftId = draftId;
             progress('.content-wrapper', true);
             $.get(URL_ROOT + "/pages/fetchDraft/" + draftId + '/' + tablePrefix).done(function (data) {
                 previewEditor.value(data);
                 kendo.drawing.drawDOM($(previewEditor.body), {
                     paperSize: 'A4',
                     margin: {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"},
                     scale: 0.7,
                     forcePageBreak: ".page-break",
                     multipage: true,
                     template: $(`#page-template-body_${tablePrefix}`).html()
                 }).then(function (group) {
                     return kendo.drawing.exportPDF(group, {});
                 }).done(function (data) {
                     if (closedStatus)
                         toolbar.hide("#submitReport");
                     else
                         toolbar.show("#submitReport");
                     progress('.content-wrapper');
                     draftWindow.center().open().maximize().title(closedStatus ? {
                         encoded: false,
                         text: "<span class=\"text-danger text-bold\">Report Submission Closed!</span>"
                     } : '');
                     pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                     setTimeout(() => pdfViewer.activatePage(1), 500)
                 });
             });
         })*/
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
