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
                            <?php echo 'Draft Report (Start Monthly Report Here)'; ?>
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
                        <?php /** @var array $drafts */
                        foreach ($drafts as $table_prefix => $draft) { ?>
                            <?php if (count($draft) > 0): ?>
                                <div class="col-md-6 col-sm-6 col-xs-12" id="draft_<?php echo $draft['draft_id']; ?>" title="<?php echo $target_month?? ''; ?> <?php echo $target_year?? ''; ?>">
                                    <div class="info-box p-0">
                                <span class="info-box-icon bg-gray-light border rounded-0 rounded-left"><svg
                                            class="fontastic-draft"
                                            style="fill: currentColor"><use
                                                xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use></svg></span>

                                        <div class="info-box-content">
                                            <div class="info-box-text text-bold"> Draft <span
                                                        class="text-<?php echo $table_prefix === 'nmr'? 'primary' : 'warning'; ?>">(<?php echo flashOrFull($table_prefix) ?> Report) </span>
                                                <a href="#"
                                                   class="fa fa-ellipsis-v font-weight-lighter float-right draft-menu w3-text-dark-grey"
                                                   data-toggle="dropdown"
                                                   role="button"></a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                 <a class="dropdown-item"
                                       href="<?php echo URL_ROOT . '/pages/edit-draft/' . $draft['draft_id'] . '/' . $table_prefix; ?>"
                                                    ><i class="fa fa-file-edit"></i> Edit</a>
                                                    <a class="dropdown-item preview-btn"
                                                       data-draft-id="<?php echo $draft['draft_id']; ?>"
                                                       data-title="<?php echo $draft['title']; ?>"
                                                       data-table-prefix="<?php echo $table_prefix; ?>"
                                                       href="#"
                                                    ><i class="fa fa-play-circle-o"></i> Preview</a>

                                                    <a class="dropdown-item delete-draft-btn d-none" href="#"
                                                       data-table-prefix="<?php echo $table_prefix; ?>"
                                                       data-draft-id="<?php echo $draft['draft_id']; ?>"
                                                       data-parent="#draft_<?php echo $draft['draft_id']; ?>"><i
                                                                class="fa fa-trash-o"></i> Delete</a>
                                                </div>
                                            </div>
                                            <span class="text-sm"><i
                                                        class="fa fa-calendar"></i> <?php echo echoDateOfficial($draft['time_modified'], true); ?></span>
                                            <span style="font-size: 0.7rem;display: block"><i
                                                        class="fa fa-clock-o"></i> <?php echo getTime($draft['time_modified']); ?></span>
                                            <a href="#"
                                               class="float-right text-sm font-poppins w3-text-dark-grey preview-btn"
                                               data-table-prefix="<?php echo $table_prefix; ?>"
                                               data-draft-id="<?php echo $draft['draft_id']; ?>"
                                               data-title="<?php echo $draft['title']; ?>"><i
                                                        class="fa fa-play-circle-o"></i> Preview</a>
                                            <a href="<?php echo URL_ROOT . '/pages/edit-draft/' . $draft['draft_id'] . '/' . $table_prefix; ?>"
                                               class="float-right text-sm font-poppins w3-text-dark-grey edit-btn mx-4"
                                               data-table-prefix="<?php echo $table_prefix; ?>"
                                               data-draft-id="<?php echo $draft['draft_id']; ?>"
                                               data-title="<?php echo $draft['title']; ?>"><i
                                                        class="fa fa-file-edit"></i> Edit</a>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                            <?php else: ?>
                                <h5>No <?php echo flashOrFull($table_prefix) ?> Report Draft Available!</h5>
                            <?php endif; ?>
                        <?php } ?>
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
    #previewEditorParent .k-editor {
        visibility: hidden!important;
        z-index: -1!important;
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
        jQSelectors.draftPreviewEditor = $("<div id='previewEditorParent'><textarea id='previewEditor' style='width: 100%;'/></div>").appendTo("body");

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
            previewEditor = $("#previewEditor").kendoEditor({
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
            let tablePrefix = $(e.currentTarget).data('tablePrefix');
            $.get(URL_ROOT + "/pages/fetchDraft/" + draftId + '/' + tablePrefix).done(function (data, successTextStatus, jQueryXHR) {

                previewEditor.value(data);
                kendo.drawing.drawDOM($(previewEditor.body), {
                    paperSize: 'a3',
                    margin: "1.3cm",
                    multipage: true,
                    forcePageBreak: ".page-break"
                }).then(function (group) {
                    // Render the result as a PDF file
                    return kendo.drawing.exportPDF(group, {});
                })
                    .done(function (data) {
                        draftWindow.center().open().maximize();
                        pdfViewer.fromFile({data: data.split(',')[1]}); // For versions prior to R2 2019 SP1, use window.atob(data.split(',')[1])
                        setTimeout(() => pdfViewer.activatePage(1), 500)
                    });
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