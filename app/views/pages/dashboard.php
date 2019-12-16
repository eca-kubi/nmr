<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group" id="box_group">
            <div class="box collapsed">
                <div class="box-header">
                    <h5 class="box-title text-bold d-none"></h5>
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
                            <li class="k-state-active">Editor</li>
                            <li>Preview</li>
                        </ul>
                        <div id="editorTab">
                            <div id="editorActionToolbar"></div>
                            <div>
                                <textarea name="" id="editor" cols="30" rows="10"></textarea>
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
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>

<script>
    let editor;
    $(function () {
        $(".content").kendoRippleContainer();
        $("#editorTabStrip").kendoTabStrip({
            select(e) {
                if (e.contentElement.id === "previewTab") {
                    $("#previewContent").html(editor.value());
                }
            }
        });
        $("#editorActionToolbar").kendoToolBar({
            items: [
                {
                    type: "button",
                    text: "Save Draft",
                    icon: "save",
                    click: function (e) {

                    }
                },
                {
                    type: "button",
                    text: "Clear",
                    icon: "refresh-clear",
                    click: function (e) {

                    }
                }
            ]
        });
        editor = $("#editor").kendoEditor({
            tools: [
                "bold",
                "italic",
                "underline",
                "strikethrough",
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
                "viewHtml",
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
    });
</script>
</body>
</html>