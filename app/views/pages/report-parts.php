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
                        <h5 class="box-title text-bold"><i class="fa fa-file"></i>
                            <?php echo 'Report Parts <span class="text-primary">(Flash Report)</span>'; ?>
                        </h5>
                        <div class="box-tools pull-right ml-auto <?php echo isITAdmin($current_user->user_id) ? '' : 'd-none'; ?>">
                            <a type="button" href="<?php echo URL_ROOT . '/pages/add-report-part' ?>"
                               class="btn btn-app btn-box-tool btn-outline-light btn-sm">
                                <i class="fa fa-file"></i> <span><i
                                            class="fa fa-plus"></i> Add Report Part</span>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($report_parts) && is_array($report_parts) && count($report_parts) > 0): ?>
                            <?php foreach ($report_parts as $report_part) { ?>
                                <div class="col-md-4 col-sm-6 col-xs-12"
                                     id="#report_part_<?php echo $report_part['report_part_id']; ?>">
                                    <div class="info-box p-0">
                                        <span class="info-box-icon bg-gray-light border rounded-0 rounded-left"><i
                                                    class="fa fa-file"></i></span>

                                        <div class="info-box-content">
                                            <div class="row px-2"><span
                                                        class="info-box-text text-bold"> <?php echo $report_part['description'] ?> </span>

                                                <div class="ml-auto"><a href="#"
                                                                        class="fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey"
                                                                        data-toggle="dropdown" role="button"></a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                        <a class="dropdown-item preview-btn"
                                                           data-table-prefix="<?php echo 'nmr'; ?>"
                                                           data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                                           data-description="<?php echo $report_part['description']; ?>"
                                                           href="#"
                                                        ><i class="fa fa-play-circle-o"></i> Preview</a>

                                                        <a class="dropdown-item"
                                                           href="<?php echo URL_ROOT . '/pages/edit-report-part/' . $report_part['report_part_id'] . '/nmr'; ?>"
                                                        ><i class="fa fa-file-edit"></i> Edit</a>

                                                        <a class="dropdown-item delete-draft-btn d-none" href="#"
                                                           data-table-prefix="<?php echo 'nmr'; ?>"
                                                           data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                                           data-parent="#report_part_<?php echo $report_part['report_part_id']; ?>"><i
                                                                    class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="#" style="position: absolute; bottom: 20px; right: 70px"
                                               class="text-sm font-poppins w3-text-dark-grey preview-btn"
                                               data-table-prefix="<?php echo 'nmr'; ?>"
                                               data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                               data-description="<?php echo $report_part['description']; ?>"><i
                                                        class="fa fa-play-circle-o"></i> Preview</a>
                                            <a href="<?php echo URL_ROOT . '/pages/edit-report-part/' . $report_part['report_part_id'] . '/nmr'; ?>"
                                               class="text-sm font-poppins w3-text-dark-grey edit-btn mx-4"
                                               style="position: absolute; bottom: 20px; right: 0"
                                               data-table-prefix="<?php echo 'nmr'; ?>"
                                               data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                               data-description="<?php echo $report_part['description']; ?>"><i
                                                        class="fa fa-file-edit"></i> Edit</a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            <?php } ?>

                        <?php else: ?>
                            <h5>No Flash Report Parts Available!</h5>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer d-none"></div>
                <!-- /.box-footer-->
            </div>
            <div class="box collapsed">
                <div class="box-header border-bottom">
                    <div class="row p-1">
                        <h5 class="box-title text-bold"><i class="fa fa-file"></i>
                            <?php echo 'Report Parts <span class="text-warning">(Full Report)</span>'; ?>
                        </h5>
                        <div class="box-tools pull-right ml-auto <?php echo isITAdmin($current_user->user_id) ? '' : 'd-none'; ?>">
                            <a type="button" href="<?php echo URL_ROOT . '/pages/add-report-part/nmr_fr' ?>"
                               class="btn btn-app btn-box-tool btn-outline-light btn-sm">
                                <i class="fa fa-file"></i> <span><i
                                            class="fa fa-plus"></i> Add Report Part</span>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($report_parts_fr) && is_array($report_parts_fr) && count($report_parts_fr) > 0): ?>
                            <?php foreach ($report_parts_fr as $report_part) { ?>
                                <div class="col-md-4 col-sm-6 col-xs-12"
                                     id="#report_part_<?php echo $report_part['report_part_id']; ?>">
                                    <div class="info-box p-0">
                                        <span class="info-box-icon bg-gray-light border rounded-0 rounded-left"><i
                                                    class="fa fa-file"></i></span>

                                        <div class="info-box-content">
                                            <div class="row px-2"><span
                                                        class="info-box-text text-bold"> <?php echo $report_part['description'] ?> </span>

                                                <div class="ml-auto"><a href="#"
                                                                        class="fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey"
                                                                        data-toggle="dropdown" role="button"></a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                        <a class="dropdown-item preview-fr-btn"
                                                           data-table-prefix="<?php echo 'nmr_fr'; ?>"
                                                           data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                                           data-description="<?php echo $report_part['description']; ?>"
                                                           href="#"
                                                        ><i class="fa fa-play-circle-o"></i> Preview</a>

                                                        <a class="dropdown-item"
                                                           data-table-prefix="<?php echo 'nmr_fr'; ?>"
                                                           href="<?php echo URL_ROOT . '/pages/edit-report-part/' . $report_part['report_part_id'] . '/nmr_fr'; ?>"
                                                        ><i class="fa fa-file-edit"></i> Edit</a>

                                                        <a class="dropdown-item delete-draft-btn d-none" href="#"
                                                           data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                                           data-parent="#report_part_<?php echo $report_part['report_part_id']; ?>"><i
                                                                    class="fa fa-trash-o"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="#" style="position: absolute; bottom: 20px; right: 70px"
                                               class="text-sm font-poppins w3-text-dark-grey preview-fr-btn"
                                               data-table-prefix="<?php echo 'nmr_fr'; ?>"
                                               data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                               data-description="<?php echo $report_part['description']; ?>"><i
                                                        class="fa fa-play-circle-o"></i> Preview</a>
                                            <a href="<?php echo URL_ROOT . '/pages/edit-report-part/' . $report_part['report_part_id'] . '/nmr_fr'; ?>"
                                               class="text-sm font-poppins w3-text-dark-grey edit-btn mx-4"
                                               style="position: absolute; bottom: 20px; right: 0"
                                               data-table-prefix="<?php echo 'nmr_fr'; ?>"
                                               data-report-part-id="<?php echo $report_part['report_part_id']; ?>"
                                               data-description="<?php echo $report_part['description']; ?>"><i
                                                        class="fa fa-file-edit"></i> Edit</a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            <?php } ?>

                        <?php else: ?>
                            <h5>No Full Report Parts Available!</h5>
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

        let showPdfViewer = () => {
            kendo.drawing.drawDOM($(previewEditor.body), {
                paperSize: 'a3',
                margin: "1.3cm",
                multipage: true,
                forcePageBreak: '.page-break'
            }).then(function (group) {
                return kendo.drawing.exportPDF(group, {});
            }).done(function (data) {
                pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                setTimeout(() => pdfViewer.activatePage(1), 500)
            });
        };

        $("a.preview-btn, a.preview-fr-btn").on("click", function (e) {
            let reportPartId = $(e.currentTarget).data('reportPartId');
            let tablePrefix = $(e.currentTarget).data('tablePrefix');
            window.reportPartId = reportPartId;
            let description = $(e.currentTarget).data('description');
            $.post(URL_ROOT + "/pages/preview-content/", {
                content: editor.value()
            }, null, "html").done((data) => {
                previewEditor.value(data);
                showPdfViewer();
            });
        });
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