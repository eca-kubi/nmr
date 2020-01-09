<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight" style="margin-top: <?php //echo NAVBAR_MT; ?>">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed">
                <div class="box-header">
                    <h5 class="box-title text-bold"><span class="fa fa-wpforms text-warning"></span> Report Submissions</h5>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="editorTab">
                        <div id="editorActionToolbar"></div>
                        <div style="width: 100%">
                            <form id="editorForm">
                                    <textarea name="content" id="editor" cols="30" rows="10"
                                              style="height: 400px">
                                        <?php foreach ($submissions as $submission) {
                                            echo "<p class='h3' style='text-align: center'>" .$submission['department'] . "</p>".
                                                $submission['content'];
                                        } ?>

                                    </textarea>
                            </form>
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
<script>
    $(function () {
        $("#editorActionToolbar").kendoToolBar({
            items: [
                {
                    type: "button",
                    text: "Close Submission",
                    icon: "save",
                    click: function (e) {
                    }
                }
            ]
        });

        editor = $("#editor").kendoEditor({
            tools: [
                "print"
            ],
            stylesheets: [
                "<?php echo URL_ROOT; ?>/public/assets/css/bootstrap/bootstrap.css"
            ],
            resizable: {
                content: true,
                //toolbar: true
            },
            encoded: false
        }).data("kendoEditor");

        editor.document.title = "NZEMA MONTHLY REPORT " + moment().format('MMMM').toUpperCase() + " " + moment().format("Y");
    });

</script>
</body>
</html>