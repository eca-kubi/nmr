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
                            <?php echo $page_title ?? 'My Reports (Flash Report)'; ?>
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
                                                        data-submission-closed="<?php echo $report['closed_status'] ?: '' ?>"
                                                        data-draft-id="<?php echo $report['draft_id'] ?>">
                                                        <span class="fa fa-file-word"> <?php echo $report['target_month'] ?></span>
                                                        <i class="mx-2 text-bold text-sm <?php echo $report['closed_status'] ? 'text-danger submission-closed' : 'text-success' ?>"><?php echo $report['closed_status'] ? '(Closed)' : '(Opened)' ?></i>
                                                        <ul>
                                                            <li>
                                                                <a class="mx-1 k-button view-btn"
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
                            <h5>No Reports Available!</h5>
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
            scrollable: false
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
                        }
                    },
                    {
                        id: "cancel",
                        type: "button",
                        text: "Cancel",
                        icon: "cancel",
                        click: function () {
                            draftWindow.close();
                        },
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
            let draftId = $(e.currentTarget).data('draftId');
            let closedStatus = $(e.currentTarget).data('closedStatus') === 1;
            let toolbar = pdfViewer.toolbar;
            window.previewDraftId = draftId;
            $.get(URL_ROOT + "/pages/fetchDraft/" + draftId).done(function (data, successTextStatus, jQueryXHR) {
                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "2cm",
                    multipage: true
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                }).done(function (data) {
                        if (closedStatus) toolbar.hide("#submitReport");
                        draftWindow.center().open().maximize().title(closedStatus? 'Submission Closed!' : '');
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