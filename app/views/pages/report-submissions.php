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
                        <h5 class="box-title text-bold"><span><svg class="fontastic-draft" style="fill: currentColor"><use
                                            xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                            Report Submissions
                        </h5>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php if (isset($report_submissions) && is_array($report_submissions) && count($report_submissions) > 0): ?>
                        <div class="accordion" id="accordionReportSubmissions">
                            <?php foreach ($report_submissions as $key => $group) { ?>
                                <div class="cardd">
                                    <div class="card-header" id="heading_<?php echo $key; ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                <?php echo $key; ?>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show"
                                         aria-labelledby="heading_<?php echo $key; ?>"
                                         data-parent="#accordionReportSubmissions">
                                        <div class="card-body border rounded-bottom">
                                            <div class="row"><?php foreach ($group as $report) { ?>
                                                    <div class="col-md-4 col-sm-6 col-xs-12"
                                                         id="<?php echo $report['report_submissions_id']; ?>">
                                                        <div class="info-box p-0"><span
                                                                    class="info-box-icon bg-gray-light border rounded-0 rounded-left"><svg
                                                                        class="fontastic-draft"
                                                                        style="fill: currentColor"><use
                                                                            xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>
                                                            <div class="info-box-content"><span
                                                                        class="info-box-text text-bold"><?php echo $report['department'] ?><a
                                                                            href="#"
                                                                            class="d-none fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey"
                                                                            data-toggle="dropdown"
                                                                            role="button"></a>
                                         <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"><a
                                                     class="dropdown-item"
                                                     href="<?php echo "" ?>"
                                                     target="_blank"><i class="fa fa-file-edit"></i> Edit</a>
                                        </div>
                                    </span>
                                                                <span class="text-sm"><i
                                                                            class="fa fa-calendar"></i> <?php echo echoDateOfficial($report['date_submitted'], true); ?></span>
                                                                <span style="font-size: 0.7rem;display: block"><i
                                                                            class="fa fa-clock-o"></i> <?php echo getTime($report['date_submitted']); ?></span>
                                                                <a href="#"
                                                                   class="float-right text-sm font-poppins w3-text-dark-grey preview-btn"
                                                                   data-report-submissions-id="<?php echo $report['report_submissions_id']; ?>"
                                                                   data-title="<?php echo $report['department']; ?>"><i
                                                                            class="fa fa-play-circle-o"></i> Preview</a>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>
                                                        <!-- /.info-box -->
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php else: ?>
                        <h5>No Report Submissions!</h5>
                    <?php endif; ?>
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

        $("a.preview-btn").on("click", function (e) {
            let currentTarget = $(e.currentTarget);
            let reportSubmissionsId = currentTarget.data('reportSubmissionsId');
            let title = currentTarget.data('title');
            let departmentId = currentTarget.data('departmentId');
            let currentMonth = currentTarget.data('currentMonth');
            let currentYear = currentTarget.data('currentYear');
            $.get(`${URL_ROOT}/pages/get-submitted-report/${reportSubmissionsId}`, {}, null, "json").done(function (data, successTextStatus, jQueryXHR) {

                previewEditor.value(data.content ? data.content : "");
                kendo.drawing.drawDOM($(previewEditor.body), {
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
                        draftWindow.center().open();
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

</script>
</body>
</html>