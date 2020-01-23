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
                            <?php echo $page_title; ?>
                        </h5>
                        <div class="box-tools pull-right ml-auto <?php echo isITAdmin($current_user->user_id) ? '' : 'd-none'; ?>">
                            <button type="button" class="btn btn-app btn-box-tool btn-outline-light btn-sm"
                                    data-toggle="dropdown"
                            >
                                <i class="fa fa-file-word" style="color: goldenrod"></i> <span><i
                                            class="fa fa-plus text-success"></i> Add Draft</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item"
                                   href="<?php echo URL_ROOT . '/pages/new-draft/'; ?>"
                                   target="_blank"><i class="fa fa-file"></i> New </a>
                                <a class="dropdown-item"
                                   href="<?php echo URL_ROOT . '/pages/new-draft/?preloaded=true' ?>"><i
                                            class="fa fa-star"></i> Preloaded </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <?php if (isset($draft) && is_array($draft) && count($draft) > 0): ?>
                            <div class="col-md-4 col-sm-6 col-xs-12" id="draft_<?php echo $draft['draft_id']; ?>">
                                <div class="info-box p-0">
                                <span class="info-box-icon bg-gray-light border rounded-0 rounded-left"><svg
                                            class="fontastic-draft"
                                            style="fill: currentColor"><use
                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>

                                    <div class="info-box-content">
                                    <span class="info-box-text text-bold"><?php echo $draft['title'] ?><a href="#"
                                                                                                          class="fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey"
                                                                                                          data-toggle="dropdown"
                                                                                                          role="button"></a>
                                         <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
<!--          <a class="dropdown-item" href="#"><i class="fa fa-play-circle-o"></i> Preview</a>
                                -->          <a class="dropdown-item"
                                                href="<?php echo URL_ROOT . '/pages/edit-draft/' . $draft['draft_id']; ?>"
                                                target="_blank"><i class="fa fa-file-edit"></i> Edit</a>
                                             <a class="dropdown-item delete-draft-btn d-none" href="#"
                                                data-draft-id="<?php echo $draft['draft_id']; ?>"
                                                data-parent="#draft_<?php echo $draft['draft_id']; ?>"><i
                                                         class="fa fa-trash-o"></i> Delete</a>
                                        </div>
                                    </span>
                                        <span class="text-sm"><i
                                                    class="fa fa-calendar"></i> <?php echo echoDateOfficial($draft['time_modified'], true); ?></span>
                                        <span style="font-size: 0.7rem;display: block"><i
                                                    class="fa fa-clock-o"></i> <?php echo getTime($draft['time_modified']); ?></span>
                                        <a href="#"
                                           class="float-right text-sm font-poppins w3-text-dark-grey preview-btn"
                                           data-draft-id="<?php echo $draft['draft_id']; ?>"
                                           data-title="<?php echo $draft['title']; ?>"><i
                                                    class="fa fa-play-circle-o"></i> Preview</a>
                                        <a href="<?php echo URL_ROOT . '/pages/edit-draft/' . $draft['draft_id']; ?>"
                                           class="float-right text-sm font-poppins w3-text-dark-grey edit-btn mx-4"
                                           data-draft-id="<?php echo $draft['draft_id']; ?>"
                                           data-title="<?php echo $draft['title']; ?>"><i
                                                    class="fa fa-file-edit"></i> Edit</a>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                                <!--<div class="w3-card p-0 collapse rounded" id="previewBox">
                                    <div class="info-box-content">OK</div>
                                </div>-->
                            </div>
                        <?php else: ?>
                            <h5>No Draft Available!</h5>
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
                    "pager", "zoom", "toggleSelection", "search", "download", "print"
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

        $("a.preview-btn").on("click", function (e) {
            let draftId = $(e.currentTarget).data('draftId');
            window.previewDraftId = draftId;
                let title = $(e.currentTarget).data('title');
            $.get(URL_ROOT + "/pages/fetchDraft/" + draftId).done(function (data, successTextStatus, jQueryXHR) {

                previewEditor.value(data);
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